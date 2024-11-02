import './permission'
import './styles/index.scss'
import 'virtual:svg-icons-register'

import { createApp } from 'vue'

import App from './App.vue'
import config from './config'
import install from './install'

const app = createApp(App)
app.use(install)
app.mount('#app')

console.log(
    `%cLikeadmin-PHP v${config.version}`,
    'background: #4A5DFF; color: white; font-size: 10px; padding: 4px 8px; border-radius: 4px;'
)
