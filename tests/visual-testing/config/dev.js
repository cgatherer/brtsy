
const configMaker = require('./shared/config-maker')
const id = 'backstop_dev'
const referenceDomain = 'https://test-brtsy.pantheonsite.io'
const testDomain = 'https://dev-brtsy.pantheonsite.io'
module.exports = configMaker({ id, referenceDomain, testDomain })