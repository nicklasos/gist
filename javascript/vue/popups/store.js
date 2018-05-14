import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

const state = {
  notification: {
    active: false,
    title: '',
    body: '',
  },
  confirmation: {
    active: false,
    title: '',
    body: '',
    resolve: null,
    reject: null,
  },
};

const mutations = {
  showNotification(state, {title, body}) {
    state.notification.active = true;
    state.notification.title = title;
    state.notification.body = body;
  },
  showConfirmation(state, payload) {
    Object.assign(state.confirmation, payload);
  },
  hideConfirmation(state) {
    state.confirmation = {
      active: false,
      title: '',
      body: '',
      resolve: null,
      reject: null,
    };
  },
};

const actions = {
  confirm({commit}, {title, body}) {
    return new Promise((resolve, reject) => {
      commit('showConfirmation', {
        active: true,
        title,
        body,
        resolve,
        reject,
      });
    });
  },
};

const getters = {};

export default new Vuex.Store({
  state,
  mutations,
  actions,
  getters,
});
