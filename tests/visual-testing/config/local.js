
const configMaker = require('./shared/config-maker')
const id = 'backstop_local'
const referenceDomain = 'https://dev-brtsy.pantheonsite.io'
const testDomain = 'http://nginx.brtsy.internal'
module.exports = configMaker({ id, referenceDomain, testDomain })