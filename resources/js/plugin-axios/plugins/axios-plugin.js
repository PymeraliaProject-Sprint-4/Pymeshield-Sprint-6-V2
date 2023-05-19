import api from '../api';

export default {
  install: (app) => {
    app.config.globalProperties.$axios = api;
  },
};
