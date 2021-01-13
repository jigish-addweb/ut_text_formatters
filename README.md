# UT Text Formatters

Provides custom formatter for the following field types: `string`,
`list_string`, `text_with_summary`, `text_long`, `string_long`, `text`


## Usage

Manage the display of entities and adjust the display format to one of these
choices `ROT13`, `Slugify`, `Tooltip`

## Pre-requisites

The `Tooltip` formatter is dependent on [qtip library]
(web/modules/custom/ct_manager/ct_manager.module). For minimizing dependency,
this module uses `CDN` resource located [here]
(https://img1.wynimg.com/static/js/plugins/jquery.qtip.min.js_bak). 
