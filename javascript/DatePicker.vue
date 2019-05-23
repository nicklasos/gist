<template>
    <form class="datepicker">

        <div id="datepicker-trigger">{{ formatDates(start, end) }}</div>

        <i class="material-icons">arrow_drop_down</i>

        <AirbnbStyleDatepicker
            :trigger-element-id="'datepicker-trigger'"
            :mode="'range'"
            :fullscreen-mobile="true"
            :date-one="start"
            :date-two="end"
            @apply="apply"
            :close-after-select="false"
            :showShortcutsMenuTrigger="false"
            :show-action-buttons="true"
            :endDate="endDate"
            @date-one-selected="val => { start = val }"
            @date-two-selected="val => { end = val }"
        />

        <v-btn
            small
            flat
            fab
            class="btn-prev"
            @click="prev"
        >
            <i class="material-icons">navigate_before</i>
        </v-btn>

        <v-btn
            small
            fab
            flat
            class="btn-next"
            @click="next"
        >
            <i class="material-icons">navigate_next</i>
        </v-btn>

    </form>
</template>

<script>
    // Usage:
    // <date-picker
    //   :date-start.sync="2019-01-01"
    //   :date-end.sync="2019-01-15"
    //   @apply="on apply function"
    // ></date-picker>

    import {formatDates} from './../../functions';
    import format from 'date-fns/format';
    import parse from 'date-fns/parse';
    import subDays from 'date-fns/sub_days';
    import addDays from 'date-fns/add_days';
    import differenceInDays from 'date-fns/difference_in_calendar_days';

    const dateFormat = 'YYYY-MM-DD';

    export default {
        props: ['dateStart', 'dateEnd'],
        data: () => ({
            dateFormat,
            endDate: format(new Date(), dateFormat),
        }),
        computed: {
            start: {
                get() {
                    return this.dateStart;
                },
                set(value) {
                    this.$emit('update:date-start', value);
                },
            },
            end: {
                get() {
                    return this.dateEnd;
                },
                set(value) {
                    this.$emit('update:date-end', value);
                },
            },
        },
        methods: {
            formatDates,
            next() {
                this.move(addDays);
            },
            prev() {
                this.move(subDays);
            },
            move(move) {
                const start = parse(this.start);
                const end = parse(this.end);

                const diff = differenceInDays(end, start) + 1;

                this.start = format(move(start, diff), dateFormat);
                this.end = format(move(end, diff), dateFormat);

                this.apply();
            },
            apply() {
                this.$emit('apply');
            },
        },
    };
</script>

<style scoped>
    .btn-next,
    .btn-prev {
        height: 25px;
        width: 25px;
    }
    .btn-prev {
        margin-right: 2px;
    }
    .btn-next {
        margin: 6px 0 6px 2px;
    }
    .btn-prev i.material-icons,
    .btn-next i.material-icons {
        font-size: 21px;
    }
</style>
