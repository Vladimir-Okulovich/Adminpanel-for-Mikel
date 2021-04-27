import Vue from 'vue'
import Vuex from 'vuex'
// import authModule from './modules/auth';
// import layoutModule from './modules/layout';
// import buySellModule from './modules/buy_sell';

import modules from './modules'

Vue.use(Vuex)

const store = new Vuex.Store({
  // modules: {
  //   auth: authModule,
  //   layout: layoutModule,
  //   buy_sell: buySellModule,
  // },
  modules,
  // Enable strict mode in development to get a warning
  // when mutating state outside of a mutation.
  // https://vuex.vuejs.org/guide/strict.html
  strict: process.env.NODE_ENV !== 'production',
})

export default store

