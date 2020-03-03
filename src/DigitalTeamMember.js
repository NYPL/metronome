import React, { Component } from 'react';
import { createClient } from 'contentful';
import Helmet from 'react-helmet';

class DigitalTeamMember extends Component {
  constructor(props) {
    super(props);

    this.state = {
      data: null
    };
  }

  componentWillMount() {
    const client = createClient({
      space: process.env.REACT_APP_SPACE_ID,
      accessToken: process.env.REACT_APP_ACCESS_TOKEN
    });

    client
      // use getEntries because it does link resolution
      .getEntries({
        'sys.id[in]': this.props.match.params.id
      })
      .then(response => {
        // extract the data from the response array
        return response.items[0].fields;
      })
      .then(fields => {
        this.setState({
          data: fields
        });
      })
      .catch(console.error);
  }

  render() {
    let memberName,
        memberTitle,
        memberEmail,
        // memberImage,
        associatedProjects,
        PortfolioGroups;

    if (this.state.data) {
      console.log(this.state.data);
      memberName = (this.state.data.first + ' ' + this.state.data.last);
      memberTitle = (this.state.data.memberTitle);
      memberEmail = (this.state.data.email);

      if (this.state.data.associatedPortfolioGroups) {
        PortfolioGroups = (this.state.data.associatedPortfolioGroups[0].fields.name);
      } else {
        PortfolioGroups = "No portfolio group";
      }
    }


    return (
      <div className="post">
        <Helmet componentName={memberName} />
        <h2>{memberName}</h2>
        <h3>{memberTitle}</h3>
        <a href={`mailto:${memberEmail}`}>{memberEmail}</a>
        <p>{PortfolioGroups}</p>

        {this.state.data &&
          this.state.data.associatedProjects.map(project => {
            if (project.fields.name) {
              associatedProjects = project.fields.name;
            } else {
              associatedProjects = "No associated projects.";
            }
            return (
              <p>{associatedProjects}</p>
            );
          })}
      </div>
    );
  }
}

export default DigitalTeamMember;
