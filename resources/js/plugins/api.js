import axios from 'axios'; //importo la libreria axios per a fer peticions http

export default {
  install: (app) => {
    const api = axios.create({
      baseURL: 'http://localhost/api/CursosCalificar-datos'//Url de la ruta on recullo les dades a la API
    });
    //Afegixo la propietat $api al objecte global de la aplicació VUE, per a puguer accedir desde qualsevol component
    app.config.globalProperties.$api = api;
  }
}
