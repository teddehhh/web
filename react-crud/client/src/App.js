import axios from 'axios';
import { useEffect, useState } from 'react';
import './App.css';
import Form from './components/Form';
import Grid from './components/Grid';

function App() {
  const [workers, setWorkers] = useState([]);
  const [onEdit, setOnEdit] = useState(null);

  const getWorkers = async () => {
    try {
      const res = await axios.get('http://localhost:5000');
      setWorkers(res.data);
    } catch (error) {
      console.log('getWorkersError');
    }
  };

  useEffect(() => {
    getWorkers();
  }, [setWorkers]);
  return (
    <div className="App">
      <Form
        workers={workers}
        setWorkers={setWorkers}
        onEdit={onEdit}
        setOnEdit={setOnEdit}
      />
      <Grid workers={workers} setWorkers={setWorkers} setOnEdit={setOnEdit} />
    </div>
  );
}

export default App;
