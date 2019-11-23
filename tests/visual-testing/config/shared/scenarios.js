
const links = require('./live-links.json')
const baseScenario = require('./base-scenario')
module.exports = (referenceDomain, testDomain) =>
  links
    .filter(item => !!item.title)
    .map(item => ({
      ...baseScenario,
      label: `${item.title} (${item.url})`,
      url: `${testDomain}${item.url}`,
      referenceUrl: `${referenceDomain}${item.url}`,
    }))