const express = require('express');
const {
  getWorkers,
  addWorker,
  deleteWorker,
  updateWorker,
} = require('../controllers/worker');
const router = express.Router();

router.get('/', getWorkers);
router.post('/', addWorker);
router.delete('/:id', deleteWorker);
router.put('/:id', updateWorker);

module.exports = router;
