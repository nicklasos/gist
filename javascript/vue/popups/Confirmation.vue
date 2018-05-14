<template>
    <v-layout row justify-center>
        <v-btn color="primary" dark @click.native.stop="$store.state.confirmation.active = true">Open Confiration
        </v-btn>
        <v-dialog v-model="$store.state.confirmation.active" max-width="290" persistent>
            <v-card>
                <v-card-title class="headline">{{ $store.state.confirmation.title }}</v-card-title>
                <v-card-text>{{ $store.state.confirmation.body }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat="flat" @click.native="confirm">
                        OK
                    </v-btn>
                    <v-btn color="green darken-1" flat="flat" @click.native="cancel">
                        Cancel
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
  export default {
    computed: {
      confirmation() {
        return this.$store.state.confirmation;
      }
    },
    methods: {
      confirm() {
        this.confirmation.resolve(true);
        this.$store.commit('hideConfirmation');
      },
      cancel() {
        this.confirmation.resolve(false);
        this.$store.commit('hideConfirmation');
      },
    },
  };
</script>

<style scoped>

</style>