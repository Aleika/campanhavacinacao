import React, { useEffect, useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import api from '../../services/api';
import Menu from '../../components/MenuCidadao';
import Select from 'react-select';
import { Button, Input, Label, FormGroup, Form } from 'reactstrap';

export default function index() {
  const [pontoVacinacao, setPontoVacinacao] = useState('');
  const [horario, setHorario] = useState('');
  const [dataAgendado, setDataAgendado] = useState('');
  const [grupoAtendimento, setGrupoAtendimento] = useState('');
  const [pontosVacinacao, setPontosVacinacao] = useState([]);
  const [gruposAtendimentoDisponiveis, setGruposAtendimentoDisponiveis] = useState([]);
  const [horariosDisponiveis, setHorariosDisponiveis] = useState([]);
  const [municipios, setMunicipios] = useState([]);
  const [municipio, setMunicipio] = useState('');

  const history = useHistory();

  const token = localStorage.getItem("access_token");

  useEffect(() => {
    if (localStorage.getItem("access_token") !== null) {
      const user = JSON.parse(localStorage.getItem("user"));
      if (user.perfil !== 2) {
        alert("Sem permissão de acesso");
        history.push('/');
      }
    }
  }, []);

  useEffect(() => {
    (async () => {
      const grupos = await api.get("/grupoatendimento/gruposPorIdade", { headers: { "Authorization": `Bearer ${token}` } });
      setGruposAtendimentoDisponiveis(grupos.data);
    })();

    (async () => {
      const municipiosLista = await api.get('/municipio', { headers: { "Authorization": `Bearer ${token}` } });
      setMunicipios(municipiosLista.data.data);
    })();

  }, []);

  useEffect(() => {
    (async () => {
      const pontos = await api.get('/pontosvacinacao?municipio=' + municipio, { headers: { "Authorization": `Bearer ${token}` } });
      setPontosVacinacao(pontos.data.data);
    })();

  }, [municipio]);

  useEffect(() => {
    console.log(dataAgendado, pontoVacinacao);
    (async () => {
      const horario = await api.get(`/horario?pontoVacinacao=` + pontoVacinacao + `&dataAgendado='` + dataAgendado + `'`, { headers: { "Authorization": `Bearer ${token}` } });
      setHorariosDisponiveis(horario.data.data);
    })();

  }, [pontoVacinacao, dataAgendado]);

  async function handleAgendamento(e) {
    e.preventDefault();

    const data = {
      pontoVacinacao,
      horario,
      dataAgendado,
      grupoAtendimento
    };

    api.post('/agendamento', data, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        alert(response.data.message);
        history.push('/comprovante');
      })
      .catch(error => {
        if (error.response.data.message != undefined) {
          alert(error.response.data.message);
          history.push('/comprovante');
        } else {
          alert(error.response.data);
        }
      })
  }

  return (
    <div>
      <Menu menu="Agendamento" />
      <main className="bg-gray-200">
        <div className="flex flex-col pt-24 container mx-auto">
          <div className="flex text-gray-700">
            <h3 className="text-gray-700 mb-8 font-bold ml-2 mt-1">
              <span className="ml-2">Cadastrar Agendamento</span>
            </h3>
          </div>
          <div className="bg-white rounded shadow p-4 container mx-auto mb-10">
            <div className="flex flex-col justify-center container">
              <div className="block overflow-x-auto whitespace-no-wrap">
                <Form onSubmit={handleAgendamento}>
                  <FormGroup>
                    <Label> Grupo de atendimento *</Label>
                    <Input required type='select' value={grupoAtendimento} onChange={e => setGrupoAtendimento(e.target.value)}>
                      <option value="0">Selecione um grupo</option>
                      {gruposAtendimentoDisponiveis.map(({ id, nome, idade }) => {
                        return (
                          <option value={id} key={id}>
                            {nome} ({idade} anos)
                          </option>
                        );
                      })}
                    </Input>
                  </FormGroup>
                  <FormGroup>
                    <Label> Municipio *</Label>
                    <Input required type="select" value={municipio} onChange={e => setMunicipio(e.target.value)}>
                      <option value="0">Selecione um muncípio</option>
                      {municipios.map(({ id, nome }) => {
                        return (
                          <option value={id} key={id}>
                            {nome}
                          </option>
                        );
                      })}
                    </Input>
                  </FormGroup>
                  <FormGroup>
                    <Label> Pontos de Vacinação * </Label>
                    <Input required type="select" value={pontoVacinacao} onChange={e => setPontoVacinacao(e.target.value)}>
                      <option value="0">Selecione um ponto de vacinacao</option>
                      {pontosVacinacao.map(({ id, nome }) => {
                        return (
                          <option value={id} key={id}>
                            {nome}
                          </option>
                        );
                      })}
                    </Input>
                  </FormGroup>
                  <FormGroup>
                    <Label> Data agendamento * </Label>
                    <Input
                      id="dataAgendado"
                      name="Data Agendado"
                      type="date"
                      required
                      onChange={e => setDataAgendado(e.target.value)}
                    />
                  </FormGroup>
                  <FormGroup>
                    <Label> Hora do agendamento * </Label>
                    <Input required type="select" value={horario} onChange={e => setHorario(e.target.value)}>
                      <option value="0">Selecione um horário</option>
                      {horariosDisponiveis.map(({ id, descricao }) => {
                        return (
                          <option value={id} key={id}>
                            {descricao}
                          </option>
                        );
                      })}
                    </Input>
                  </FormGroup>
                  <Button color="primary" type="submit"> Cadastrar </Button>
                </Form>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div >
  )
}