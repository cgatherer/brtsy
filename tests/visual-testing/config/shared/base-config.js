
module.exports = {
  report: ['browser'],
  onBeforeScript: 'puppet/onBefore.js',
  onReadyScript: 'puppet/onReady.js',
  engine: 'puppeteer',
  engineOptions: {
    args: ["--no-sandbox", "--ignore-certificate-errors", "--allow-insecure-localhost"]
  },
  engineFlags: ["--ignore-certificate-errors", "--allow-insecure-localhost"],
  asyncCaptureLimit: 5,
  asyncCompareLimit: 5,
  debug: false,
  debugWindow: false,
}