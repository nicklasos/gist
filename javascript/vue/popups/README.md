# Vuetify notification and confirmation popups.

### Usage:

```javascript
<template>
    <v-container
      <v-btn @click="remove">Remove</v-btn>
    </v-container>
</template>
<script>
  export default {
    methods: {
      async remove() {
          if (await confirm('Are you sure?')) {
              axios.delete(url(`users/1`)).then(() => {
                // ...  
              }).catch(catchError());
          }
      },
    },
  };
</script>
```