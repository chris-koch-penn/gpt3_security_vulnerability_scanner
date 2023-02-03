import os
from flask import Flask, request
app = Flask(__name__)


@app.route("/api/<something>")
def test_sources_7(something):

    os.system(request.remote_addr)

    return "foo"


if __name__ == "__main__":
    app.run(debug=True)
