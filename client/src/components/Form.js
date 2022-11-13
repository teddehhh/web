import axios from 'axios';
import { useEffect, useState } from 'react';

function Form({ workers, setWorkers, onEdit, setOnEdit }) {
  const [name, setName] = useState('');
  const [salary, setSalary] = useState('');
  const [buttonLabel, setButtonLabel] = useState('Add');

  useEffect(() => {
    if (onEdit) {
      setName(onEdit.name);
      setSalary(onEdit.salary);
      setButtonLabel('Save');
    }
  }, [onEdit]);

  const HandleSubmit = async (e) => {
    e.preventDefault();
    if (onEdit && workers.find((worker) => worker.id === onEdit.id)) {
      await axios
        .put(`http://localhost:5000/${onEdit.id}`, {
          name,
          salary,
        })
        .then(() => {
          const editWorker = workers.find((worker) => worker.id === onEdit.id);
          editWorker.name = name;
          editWorker.salary = salary;
          setWorkers([...workers]);
        });
    } else {
      await axios
        .post(`http://localhost:5000`, { name, salary })
        .then((res) => {
          setWorkers([...workers, { id: res.data, name, salary }]);
        });
    }
    setName('');
    setSalary('');
    setButtonLabel('Add');
    setOnEdit(null);
  };

  return (
    <form onSubmit={HandleSubmit}>
      <input
        value={name}
        onChange={(e) => setName(e.target.value)}
        type="text"
        name="name"
        placeholder="Name"
      />
      <input
        value={salary}
        onChange={(e) => setSalary(e.target.value)}
        type="text"
        name="salary"
        placeholder="Salary"
      />
      <input type="submit" value={buttonLabel} />
    </form>
  );
}

export default Form;
