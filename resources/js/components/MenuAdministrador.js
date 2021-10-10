import React, { useState, useEffect } from "react";
import { Link, useHistory } from "react-router-dom";
import {
  Collapse,
  Navbar,
  NavbarToggler,
  NavbarBrand,
  Nav,
  NavItem,
  NavLink,
  UncontrolledDropdown,
  DropdownToggle,
  DropdownMenu,
  DropdownItem,
  NavbarText
} from "reactstrap";
import { FiLogOut } from 'react-icons/fi';
import api from './../services/api';

export default function Menu({ nav = "" }) {
  const history = useHistory();
  const [token] = useState(localStorage.getItem('access_token'));
  const [nome, setNome] = useState('');

  if (token === '' || token === null) {
    history.push('/');
  }

  function handleLogout() {
    const data = {
      token: localStorage.getItem("access_token")
    }
    api.post(`/auth/logout`, data, { headers: { "Authorization": `Bearer ${token}` } })
      .then(response => {
        alert(response.data.message);
        localStorage.clear();
        history.push('/');
      })
      .catch(error => {
        alert(error);
      });
  }

  useEffect(() => {
    const usuario = JSON.parse(localStorage.getItem("user"));
    setNome(usuario.nome);
  }, []);

  const [isOpen, setIsOpen] = useState(false);

  const toggle = () => setIsOpen(!isOpen);

  return (
    <div>
      <Navbar color="light" light expand="md">
        <NavbarBrand href="/">Home</NavbarBrand>
        <NavbarToggler onClick={toggle} />
        <Collapse isOpen={isOpen} navbar>
          <Nav className="mr-auto" navbar>
            <NavItem>
              <NavLink href="#/pontos/listar">Pontos de Vacinação</NavLink>
            </NavItem>
            <NavItem>
              <NavLink href="#/grupos/listar">Grupos de Atendimento</NavLink>
            </NavItem>
          </Nav>
          <UncontrolledDropdown >
            <DropdownToggle nav caret>
              <NavbarText> {nome}</NavbarText>
            </DropdownToggle>
            <DropdownMenu right>
              <DropdownItem onClick={handleLogout}>
                <FiLogOut size={14} /> Sair
              </DropdownItem>
            </DropdownMenu>
          </UncontrolledDropdown>
        </Collapse>
      </Navbar>
    </div >
  );
}
