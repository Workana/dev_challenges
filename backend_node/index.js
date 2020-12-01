const app = require("express")();
const bodyParser = require("body-parser");
const cors = require("cors");
const port = 8082;
app.use(bodyParser.json());

app.use(cors());


app.get('/issue/:issue', function(req, res) {
    return res.json({issue: parseInt(req.params.issue,10)})
})


app.listen(port, () => {
    console.log(`Backend node listen in port ${port}`);
});
