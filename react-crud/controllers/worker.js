const db = require('../database/db');
const con = require('../database/db');

function getWorkers(_, res) {
  const q = 'SELECT * FROM workers';
  con.query(q, (err, data) => {
    if (err) {
      return res.json(err);
    }
    return res.status(200).json(data);
  });
}

function addWorker(req, res) {
  const q = 'INSERT INTO workers SET ?';
  db.query(
    q,
    { name: req.body.name, salary: req.body.salary },
    (err, result, fields) => {
      if (err) {
        return res.json(err);
      }
      return res.status(200).json(result.insertId);
    }
  );
}

function deleteWorker(req, res) {
  const q = 'DELETE FROM workers WHERE ?';
  db.query(q, { id: req.params.id }, (err) => {
    if (err) {
      return res.json(err);
    }
    return res.status(200).json('Deleted!');
  });
}

function updateWorker(req, res) {
  const q = 'UPDATE workers SET name=?, salary=? WHERE id=?';
  const values = [req.body.name, req.body.salary, req.params.id];
  db.query(q, values, (err) => {
    if (err) {
      return res.json(err);
    }
    return res.status(200).json('Updated!');
  });
}

module.exports = { getWorkers, addWorker, deleteWorker, updateWorker };
