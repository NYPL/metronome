import React, { Component } from 'react';
import { createClient } from 'contentful';
import Helmet from 'react-helmet';

class Project extends Component {
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
    let launchName;
    let launchDescription;

    if (this.state.data) {
      console.log(this.state.data);
      launchName = this.state.data.launchName;
      launchDescription = this.state.data.launchDescription;
    }

    return (
      <div className="post">
        <Helmet componentName={launchName} />
        <h2>{launchName}</h2>
        <p>{launchDescription}</p>
      </div>
    );
  }
}

export default Project;
