const express = require('express');
const router = express.Router()

const lodash = require('lodash');

function check(req, res) {

  let config = {};
  lodash.defaultsDeep(config, JSON.parse(req.body.config));

  let user = getCurrentUser();
  if (!user) {
    user = {};
  }

  if (user.isAdmin && user.isAdmin === true) {
    res.send('Welcome Admin')
  } else {
    res.send('Welcome User')
  }
}

function getCurrentUser() {
  return false;
}


router.post('/check-user', check)

module.exports = router
