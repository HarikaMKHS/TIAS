import express from 'express';
import cors from 'cors';
import nodemailer from 'nodemailer';

const app = express();
const PORT = process.env.PORT || 3000;

// Allow form submissions from your GitHub Pages site
app.use(cors({
  origin: 'https://harikamkhs.github.io'  // 👈 Your GitHub Pages origin
}));

app.use(express.urlencoded({ extended: false }));
app.use(express.json());

app.post('/contact', async (req, res) => {
  const { name, email, subject, message } = req.body;

  const transporter = nodemailer.createTransport({
    host: 'smtp-relay.brevo.com',
    port: 587,
    secure: false,
    auth: {
      user: 'your-brevo@smtp-brevo.com',     // ✅ your Brevo SMTP username
      pass: 'your-brevo-app-password'        // ✅ your Brevo app password
    }
  });

  const mailOptions = {
    from: '"Website Contact" <your-verified-email@domain.com>',
    to: 'your-verified-email@domain.com',    // ✅ where you receive emails
    replyTo: email,
    subject: subject || 'No Subject',
    text: `From: ${name} <${email}>\n\n${message}`
  };

  try {
    await transporter.sendMail(mailOptions);
    res.send("success");
  } catch (error) {
    console.error("Mailer Error:", error);
    res.status(500).send("Error sending message.");
  }
});

app.get("/", (req, res) => {
  res.send("Contact API running");
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
