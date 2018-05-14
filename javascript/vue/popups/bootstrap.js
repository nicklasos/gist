window.notify = function(title, body) {
  window.vm.$store.commit('showNotification', {title, body});
};

window.confirm = function(body, title = 'Confirmation') {
  return vm.$store.dispatch('confirm', {title, body});
};
