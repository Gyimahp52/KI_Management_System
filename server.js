// server.js
require('dotenv').config();
const express = require('express');
const bodyParser = require('body-parser');
const axios = require('axios');
const app = express();
const port = 5500;

app.use(bodyParser.json());

app.post('/send-sms', async (req, res) => {
    const { phone, username, password, role } = req.body;
    const message = `Welcome ${username}, your role is ${role}. Your password is ${password}`;
    const apiUrl = 'https://apps.mnotify.net/smsapi';
    const apiKey = process.env.MNOTIFY_API_KEY;
    const senderId = process.env.SENDER_ID;

    try {
        const response = await axios.get(apiUrl, {
            params: {
                key: apiKey,
                to: phone,
                msg: message,
                sender_id: senderId,
            },
        });

        console.log('MNotify API response:', response.data);

        if (response.data.status === '1000') {
            res.status(200).json({ success: true, message: 'SMS sent successfully' });
        } else {
            res.status(500).json({ success: false, message: 'Failed to send SMS', error: response.data });
        }
    } catch (error) {
        console.error('Error sending SMS:', error);
        res.status(500).json({ success: false, message: 'Failed to send SMS', error: error.message });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
