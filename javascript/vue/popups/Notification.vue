<template>
    <v-layout row justify-center>
        <v-dialog v-model="$store.state.notification.active" max-width="290">
            <v-card>
                <v-card-title class="headline">{{ $store.state.notification.title }}</v-card-title>
                <v-card-text>{{ $store.state.notification.body }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" flat="flat" @click.native="$store.state.notification.active = false">OK</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
  export default {};
</script>

<style scoped>

</style>