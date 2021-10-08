import React from 'react';
import { Route, Switch, HashRouter } from 'react-router-dom';
import { browserHistory, Router } from 'react-router';

import Login from './pages/Login';
import Register from './pages/Register';
import Home from './pages/Home';

import CadastroAgendamento from './pages/CadastroAgendamento';
import Comprovante from './pages/ComprovanteAgendamento';

import ListarPontosVacinacao from './pages/PontosVacinacao/Listar';
import CadastrarPontoVacinacao from './pages/PontosVacinacao/Cadastrar';
import EditarPontoVacinacao from './pages/PontosVacinacao/Editar';

import ListarGruposAtendimento from './pages/GruposAtendimento/Listar';
import CadastrarGrupoAtendimento from './pages/GruposAtendimento/Cadastrar';
import EditarGrupoAtendimento from './pages/GruposAtendimento/Editar';

import MeusDados from './pages/MeusDados';

export default function Routes() {
  return (
    <HashRouter>
      <Switch>
        <Route exact={true} path="/" component={Home} />
        <Route exact={true} path="/login" component={Login} />
        <Route exact={true} path="/register" component={Register} />
        <Route exact={true} path="/perfil" component={MeusDados} />

        <Route exact={true} path="/agendamento" component={CadastroAgendamento} />
        <Route exact={true} path="/comprovante" component={Comprovante} />

        <Route exact={true} path="/pontos/listar" component={ListarPontosVacinacao} />
        <Route exact={true} path="/pontos/cadastrar" component={CadastrarPontoVacinacao} />
        <Route exact={true} path="/pontos/editar/:id" component={EditarPontoVacinacao} />

        <Route exact={true} path="/grupos/listar" component={ListarGruposAtendimento} />
        <Route exact={true} path="/grupos/cadastrar" component={CadastrarGrupoAtendimento} />
        <Route exact={true} path="/grupos/editar/:id" component={EditarGrupoAtendimento} />
      </Switch>
    </HashRouter >

  );
}