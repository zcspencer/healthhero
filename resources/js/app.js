import './bootstrap';
import {createApp} from 'vue';
import App from './App.vue';
import LookupResults from './LookupResults.vue';
import LocalePicker from './LocalePicker.vue';
import Address from './Address.vue';
import ProviderModal from './ProviderModal.vue';

const app = createApp(App);

app.component('LookupResults', LookupResults);
app.component('LocalePicker', LocalePicker);
app.component('Address', Address);
app.component('ProviderModal', ProviderModal);

app.mount('#app');