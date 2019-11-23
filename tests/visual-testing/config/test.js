
const configMaker = require('./shared/config-maker')
const id = 'backstop_test'
const referenceDomain = 'https://live-brtsy.pantheonsite.io'
const testDomain = 'https://test-brtsy.pantheonsite.io'
module.exports = configMaker({ id, referenceDomain, testDomain })