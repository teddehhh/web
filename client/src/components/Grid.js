import axios from 'axios';

function Grid({ workers, setWorkers, setOnEdit }) {
  const HandleDelete = async (id) => {
    await axios.delete(`http://localhost:5000/${id}`).then(() => {
      const newWorkers = workers.filter((worker) => worker.id !== id);
      setWorkers(newWorkers);
    });
  };
  const HandleEdit = (item) => {
    setOnEdit(item);
  };
  return (
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Salary</th>
          <th colSpan={2}>Действие</th>
        </tr>
      </thead>
      <tbody>
        {workers.map((item, i) => (
          <tr key={i}>
            <td>{item.name}</td>
            <td>{item.salary}</td>
            <td>
              <input
                type="button"
                value="Редактировать"
                onClick={() => HandleEdit(item)}
              />
            </td>
            <td>
              <input
                type="button"
                value="Удалить"
                onClick={() => HandleDelete(item.id)}
              />
            </td>
          </tr>
        ))}
      </tbody>
    </table>
  );
}

export default Grid;
