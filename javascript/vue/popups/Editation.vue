<template>
  <v-layout row justify-center>
    <v-dialog v-model="$store.state.editation.active" max-width="450" persistent>
      <v-card>
        <v-card-title class="headline">{{ $store.state.editation.title }}</v-card-title>
        <v-card-text>
          <v-flex xs12>
            <v-text-field
              autofocus
              name="editation-field"
              v-model="$store.state.editation.body"
              @keyup.enter="confirm"
            ></v-text-field>
          </v-flex>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary darken-1" @click.native="confirm">
            Save
          </v-btn>
          <v-btn @click.native="cancel">
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-layout>
</template>

<script>
  export default {
    computed: {
      editation() {
        return this.$store.state.editation;
      }
    },
    methods: {
      confirm() {
        this.editation.resolve(this.$store.state.editation.body);
        this.$store.commit('hideEditation');
      },
      cancel() {
        this.editation.resolve(false);
        this.$store.commit('hideEditation');
      },
    },
  };
</script>

<style scoped>

</style>

