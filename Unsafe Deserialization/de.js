const jsyaml = require("js-yaml");

var express = require('express');
var app = express();
app.post('/store/:id', function (req, res) {
  let data;
  let unsafeConfig = { schema: jsyaml.DEFAULT_FULL_SCHEMA };
  data = jsyaml.safeLoad(req.params.data, unsafeConfig); 