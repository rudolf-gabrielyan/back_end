<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <style>
        #cvContainer {
            width: 100%;
            background-color: #3F51B5;
            display: inline-block;
            margin-top: 50px;
            border-radius: 10px;
            color: white;
            padding: 15px;
        }
        #cvContainer h1 {
            text-align: left;

        }
        #cvContainer h1 textarea{
            font-size: 30px;
            font-weight: bold;
            height: 40px;
        }
        #cvContainer  textarea {
            width: 100%;
            height: 100%;
            background: transparent;
            border: none;
            outline: none;
            color: white;
            resize: none;
        }
        #cvTable {
            width: 100%;
            border: 1px solid lightgrey;
            border-collapse: collapse;
        }
        #cvTable th {
            width: 200px;
            height: 80px;
            text-align: left;
            padding: 5px 10px;
            border: 1px solid lightgrey;
        }
        #cvTable td {
            word-wrap: break-word;
            width: auto;
            text-align: left;
            padding: 5px 10px;
            border: 1px solid lightgrey;
        }
        #resumeImage {
            width: 100px;
            height: 100px;
            object-fit: cover !important;
            float: left;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div id="cvContainer">
        <div>
            <img id="resumeImage" src="{{ $destinationPath }}" />
            <h1>{{$full_name}}</h1>
        </div><br /><br />
        <table id="cvTable">
            <tr>
                <th>Personal Information -</th>
                <td>{{ $personal_information }}</td>
            </tr>
            <tr>
                <th>Work Experience -</th>
                <td>{{ $experience }}</td>
            </tr>
            <tr>
                <th>Skills -</th>
                <td>{{ $skills }}</td>
            </tr>
            <tr>
                <th>Education -</th>
                <td>{{ $education }}</td>
            </tr>
            <tr>
                <th>Contacts</th>
                <td>{{ $contact }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
