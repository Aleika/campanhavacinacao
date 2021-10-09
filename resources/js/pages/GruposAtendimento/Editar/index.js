import React, { useEffect, useState } from 'react';
import { Link, useHistory, useParams } from 'react-router-dom';
import api from '../../../services/api';
import Menu from '../../../components/MenuAdministrador';
import { Button, Form, FormGroup, Label, Input } from 'reactstrap';

export default function index() {
  const history = useHistory();

  const [nome, setNome] = useState('');
  const [idadeMinima, setIdadeMinima] = useState('');

  const { id } = useParams();

  const token = localStorage.getItem("access_token");

  useEffect(() => {
    if (localStorage.getItem("access_token") !== null) {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user.perfil !== 1) {
        history.push('/');
      }
    }
  }, []);

  useEffect(() => {

    api.get('/grupoatendimento/' + id, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {

        let dados = response.data.data[0];
        setNome(dados.nome);
        setIdadeMinima(dados.idadeMinima);

      })
      .catch(error => {
        alert(error.response.data.message);
      });

  }, []);

  async function handleUpdateGrupoAtendimento(e) {
    e.preventDefault();

    const data = {
      nome,
      idadeMinima
    };

    api.put('/grupoatendimento/' + id, data, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        console.log(response)
        alert(response.data.message);

        history.push('/grupos/listar');
      })
      .catch(error => {
        console.log(error.response.data);
        alert(error.response.data);
      })
  }

  return (
    <div>
      <Menu />
      <main className="bg-gray-200">
        <div className="flex flex-col pt-24 container mx-auto">
          <div className="flex text-gray-700">
            <h3 className="cursor-pointer text-gray-700 mb-8 font-bold ml-2 mt-1">
              |<span className="ml-2"> Grupo Atendimento</span>
            </h3>
          </div>
          <div className="bg-white rounded shadow p-4 container mx-auto mb-10">
            <div className="flex flex-col justify-center container">
              <div className="block overflow-x-auto whitespace-no-wrap">
                <Form onSubmit={handleUpdateGrupoAtendimento}>
                  <FormGroup>
                    <Label> Nome *</Label>
                    <Input required placeholder="Nome"
                      value={nome}
                      onChange={e => setNome(e.target.value)} />
                  </FormGroup>
                  <FormGroup>
                    <Label >Idade Mínima *</Label>
                    <Input required placeholder="Idade"
                      value={idadeMinima}
                      type="number"
                      max="100"
                      min="1"
                      onChange={e => setIdadeMinima(e.target.value)} />
                  </FormGroup>
                  <FormGroup >
                    <Button color="primary">Editar</Button> {' '}
                    <Link to={"/grupos/listar/"} className="button" >
                      <Button color="danger" left>Cancelar</Button>
                    </Link>
                  </FormGroup>
                </Form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}