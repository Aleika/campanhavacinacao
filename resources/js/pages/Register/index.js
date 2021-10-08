import React, { useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import Menu from '../../components/Menu';
import { Button } from 'reactstrap';
import api from '../../services/api';
import './styles.scss';

export default function Register() {
  const [nome, setNome] = useState('');
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [confirmarSenha, setConfirmarSenha] = useState('');
  const [dataNascimento, setDataNascimento] = useState('');

  const history = useHistory();

  async function handleRegister(e) {
    e.preventDefault();

    const data = {
      nome,
      email,
      senha,
      dataNascimento,
      confirmarSenha,
    };

    api.post('/register', data)
      .then(response => {
        alert(response.data.message);
        history.push('/');
      })
      .catch(err => {
        const erros = err.response.data;
        let dscerros = "";
        for (let i = 0; i < erros.length; i++) {
          dscerros += erros[i].toString() + "\n";
        }
        alert(dscerros)
      });
  }

  return (
    <div>
      <Menu />

      <div className="register-container">
        <div className="content">
          <section>
            <h3>Cadastro Campanha de Vacinação contra o COVID-19</h3>
            <p>Faça seu cadastro, entre no sistema e faça o agendamento para ser vacinado contra o Covid-19.</p>

            <Link className="back-link" to="/login">
              Já possuo cadastro
            </Link>
          </section>

          <form onSubmit={handleRegister}>
            <label> Nome * </label>
            <input
              placeholder="Seu Nome"
              value={nome}
              onChange={e => setNome(e.target.value)}
              required
            />

            <label> Data de nascimento *</label>
            <input
              id="dataNascimento"
              label="Data Nascimento"
              type="date"
              onChange={e => setDataNascimento(e.target.value)}
              required
            />

            <label> Email *</label>
            <input
              type="email"
              placeholder="Seu E-mail"
              value={email}
              onChange={e => setEmail(e.target.value)}
              required
            />

            <label> Senha *</label>
            <input
              placeholder="Digite sua Senha"
              value={senha}
              type="password"
              onChange={e => setSenha(e.target.value)}
              required
            />
            <label> Confirme a senha *</label>
            <input
              placeholder="Confirme sua Senha"
              value={confirmarSenha}
              type="password"
              onChange={e => setConfirmarSenha(e.target.value)}
              required
            />

            <Button color="primary" type="submit">Cadastrar</Button>
          </form>
        </div>
      </div>
    </div>
  );
}