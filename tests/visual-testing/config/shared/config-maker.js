
const baseConfig = require('./base-config')
const paths = require('./paths')
const viewports = require('./viewports')
const scenarios = require('./scenarios')
const configMaker = ({ id, referenceDomain, testDomain }) => ({
  ...baseConfig,
  id,
  paths,
  viewports,
  scenarios: scenarios(referenceDomain, testDomain),
})
module.exports = configMaker