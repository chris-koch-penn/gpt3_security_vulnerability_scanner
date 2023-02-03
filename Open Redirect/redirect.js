
console.log('WIP')
const express = require('express');
const router = express.Router()

router.get('/login', function (req, res) {
    let followPath = req.query.path;
    if (req.session.isAuthenticated()) {
        res.redirect('http://example.com/' + followPath);
    } else {
        res.redirect('/');
    }
});

router.get('/goto', function (req, res) {
    let url = encodeURI(req.query.url);
    res.redirect(url);
});


module.exports = router
