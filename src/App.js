import React, { Component } from 'react';
import { BrowserRouter, Link, Switch, Route } from 'react-router-dom';
import Home from './Home';
import Portfolio from './Portfolio';
import Portfolios from './Portfolios';
import DigitalTeamMember from './DigitalTeamMember';
import DigitalTeamMembers from './DigitalTeamMembers';
import Components from './Components';
import Launch from './Launch';
import Launches from './Launches';
import './App.css';

class App extends Component {
  render() {
    return (
      <BrowserRouter>
        <div className="App">
          <header>
            <h1>UX Team Project Requirements Site</h1>

            <ul>
              <li><Link to="/">Home</Link></li>
              <li><Link to="/components">Components</Link></li>
              <li><Link to="/digital-team-members">Digital Team Members</Link></li>
              <li><Link to="/launches">Launches</Link></li>
              <li><Link to="/portfolios">Portfolios</Link></li>
              <li><Link to="/projects">Projects</Link></li>
              {/* <li><Link to="/related-materials">Related Materials</Link></li> */}
            </ul>
          </header>

          <main>
            <Switch>
              <Route exact path="/" component={Home} />
              <Route path="/portfolios" component={Portfolios} />
              <Route path="/portfolio/:id" component={Portfolio} />
              <Route path="/digital-team-members" component={DigitalTeamMembers} />
              <Route path="/digital-team-member/:id" component={DigitalTeamMember} />
              <Route path="/components" component={Components} />
              <Route path="/launches" component={Launches} />
              <Route path="/launch/:id" component={Launch} />
            </Switch>
          </main>
        </div>
      </BrowserRouter>
    );
  }
}

export default App;
