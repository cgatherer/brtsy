const dir = 'backstop_data'
const locations = [
  'bitmaps_reference',
  'bitmaps_test',
  'engine_scripts',
  'html_report',
  'ci_report',
]
const paths = locations.reduce((prev, curr) => {
  prev[curr] = `${dir}/${curr}`
  return prev
}, {})
module.exports = paths