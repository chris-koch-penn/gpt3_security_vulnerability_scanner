const express = require('express');
const router = express.Router()


router.post("/list-users", (req, res) => {
    var obj = req.body.users;
    var someArr = [];

    for (var i = 0; i < obj.length; i++) {
        someArr.push(obj[i]);
    }

    res.send(someArr.join(','));
});


module.exports = router
