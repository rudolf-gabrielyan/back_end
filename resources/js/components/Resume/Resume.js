import React, { useState } from 'react';
import './resume.scss'
import axios from 'axios';
import { connect } from 'react-redux';


function Resume({ user }) {

    const[message,setMessage] = useState('hide');

    const [pdfData, setPdfData] = useState({
        full_name: 'Rudolf Gabrielyan',
        personal_information: " I am Rudolf Gabrielyan. I'm 19 years old. I am studying in NPUA. I like programming.I will be happy to join your wonderful team.",
        experience: "I've worked in Profit Development Company about one year.",
        skills: "HTML,CSS,JavaScrip,JQuery,React.js,Angular,Vue.js,PHP,Laravel,Codeigniter,CakePHP...",
        education: "Now I'm studying in National Politechnical Univercity.",
        contact: "Phone Number: (077)586188, Mail: rudolf.gabrielyan29@gmail.com",
        user_id: user.data.id
    });

    const handlePdfDataChange = event => {
        event.persist();
        setPdfData({ ...pdfData, [event.target.id]: event.target.value});
    };

    const handleCreatePdf = event => {

        event.preventDefault();
        axios.post('/api/generateResume',pdfData)
        .then(res => setMessage(res.data))
        .then(()=>{
            setTimeout(()=> {
                setMessage('hide');
            },3000)
        })
    };
    return (
        <>
        {
            (message == "success") ? <div className="success">Your resume will be generated in a matter of minutes !</div>: (message == "error") ? <div className="success">Error !</div> : null
        }
        <p className="instruction">You can edit this cv template as you want !</p>
        <form className="cvForm">
            <div className="cvContainer">
                <h1><textarea onChange={handlePdfDataChange} id="full_name" value={pdfData.full_name} name="full_name"></textarea>
                </h1>
                <table className="cvTable">
                    <tbody>
                    <tr>
                        <th>Personal Information -</th>
                        <td><textarea onChange={handlePdfDataChange} id="personal_information" value={pdfData.personal_information} name="personal_information"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Work Experience -</th>
                        <td><textarea onChange={handlePdfDataChange} id="experience" value={pdfData.experience} name="experience"> </textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Skills -</th>
                        <td><textarea onChange={handlePdfDataChange} id="skills" value={pdfData.skills} name="skills"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Education -</th>
                        <td><textarea onChange={handlePdfDataChange} id="education" value={pdfData.education} name="education"> </textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>Contacts</th>
                        <td><textarea onChange={handlePdfDataChange} id="contact" value={pdfData.contact} name="contact"></textarea>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div><br/><br/>
            <button className="pdfButton" onClick={handleCreatePdf}>Create Resume</button>
        </form>
        </>
    );
}

const mapStateToProps = state => {
    return {
        user: state.user,
    }
};

export default connect(mapStateToProps)(Resume)

