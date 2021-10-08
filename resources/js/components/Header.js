import React, { useState } from 'react';
import { Link, useHistory } from 'react-router-dom';
import { AppBar, Toolbar } from '@material-ui/core';
import { FiLogOut } from 'react-icons/fi';

export default function Header() {
  const [token] = useState(localStorage.getItem('access_token'));
  const history = useHistory();

  if (token === '' || token === null) {
    history.push('/');
  }

  function handleLogout() {
    localStorage.clear();
    history.push('/');
  }

  return (
    <div className="header">
      <header>
        <div className="content">
          <Link to="/" className="menuTitle">
            <h1>Home</h1>
          </Link>
          <div>
            <button className="menuButton" onClick={handleLogout} type="button">
              <FiLogOut size={16}></FiLogOut>
            </button>
          </div>
        </div>
      </header>
    </div>
  );
}