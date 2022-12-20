const express = require('express');
const config = require('config');
const cors = require('cors');

const app = express();
const PORT = config.get('port') || 5000;

app.use(express.json());
app.use(cors());
app.use('/', require('./routes/workers.routes'));

async function start() {
  try {
    /* listening application */
    app.listen(PORT, () => {
      console.log(`app has been started on ${PORT}...`);
    });
  } catch (e) {
    console.log('server error', e.message);
    process.exit();
  }
}

start();
