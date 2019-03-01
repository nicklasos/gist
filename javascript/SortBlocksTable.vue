<template>
    <div>
            <table class="table countries-det campaigns-det">
                <thead>
                <tr>
                    <th scope="col" @click="sort('delta', 'field')">field</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in data">
                    <td>{{ item.field }}</td>
                </tr>
                </tbody>
            </table>
    </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        data: () => ({
            data: [],
            currentSort: {
                field: 'clicks',
                order: 'desc',
            },
        }),
        methods: {
            sort(delta, field) {
                if (field === this.currentSort.field) {
                    this.currentSort.order = this.currentSort.order === 'desc' ? 'asc' : 'desc';
                } else {
                    this.currentSort.order = 'desc';
                }

                this.currentSort.field = field;

                let grouped = _.groupBy(this.data, 'group_field');
                grouped = Object.keys(grouped).map(index => {
                    return [grouped[index][0]['deltas'][delta][field], grouped[index]];
                });

                const sort = ([a], [b]) => {
                    if (a > b) {
                        return this.currentSort.order === 'asc' ? 1 : -1;
                    }

                    if (a < b) {
                        return this.currentSort.order === 'asc' ? -1 : 1;
                    }

                    return 0;
                };

                this.campaigns = grouped.sort(sort).map(i => i[1]).flatMap(i => i);
            },
            fetch() {
                this.$http.get(`/data`).then(response => {
                    this.data = response.data.data;
                });
            },
        },
        mounted() {
            this.fetch();
        },
    };
</script>

<style scoped>
</style>
