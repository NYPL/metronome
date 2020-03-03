// import React, { Component, createElement } from 'react';
import React, { Component } from 'react';
import { createClient } from 'contentful';
import Helmet from 'react-helmet';
// import marksy from 'marksy';
// import { documentToReactComponents } from '@contentful/rich-text-react-renderer';

// const getMarkup = field => {
//   if (!field) return null;
//   const compile = marksy({
//     createElement,
//     elements: {}
//   });
//   return compile(field).tree;
// };

class Portfolio extends Component {
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
    let portfolioName,
        portfolioPrefix,
        portfolioDescription,
        portfolioAreas,
        portfolioLeadName;
        // portfolioUXLead;

    if (this.state.data) {
      portfolioName = this.state.data.name;
      portfolioPrefix = this.state.data.prefix;
      portfolioDescription = this.state.data.description;
      portfolioAreas = this.state.data.areasCovered;
      portfolioLeadName = (this.state.data.lead.fields.first + ' ' + this.state.data.lead.fields.last);
    }

    return (
      <div className="post">
        <Helmet componentName={portfolioName} />
        <h2>{portfolioName}</h2>
        <p>{portfolioPrefix}</p>
        <p>{portfolioDescription}</p>
        <p>{portfolioAreas}</p>
        <p>{portfolioLeadName}</p>
      </div>
    );
  }
}

export default Portfolio;
