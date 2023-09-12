const express = require('express');
const { MongoClient } = require('mongodb');
const app = express();
const port = process.env.PORT || 3000;
const mongoURI = 'mongodb+srv://ak5110467:iMAXJdpMFw6I6kTL@cluster0.s3qwqlk.mongodb.net/?retryWrites=true&w=majority';
const mongoDatabase = 'cess';

// Middleware to parse JSON
app.use(express.json());
app.use(express.static('public')); // Assuming your CSS file is in a 'public' directory


app.post('/submit', async (req, res) => {
  const { type, district, date, company } = req.body;

  const client = new MongoClient(mongoURI, { useNewUrlParser: true, useUnifiedTopology: true });

  try {
    await client.connect();
    const db = client.db(mongoDatabase);
    const collection = db.collection('cesss');

    const document = {
      type: type,
      district: district,
      date: date,
      company: company,
    };

    const result = await collection.insertOne(document);

    if (result.insertedCount === 1) {
      res.status(200).json({ message: 'Data inserted into MongoDB.' });
    } else {
      res.status(500).json({ error: 'Error inserting data into MongoDB.' });
    }
  } catch (err) {
    res.status(500).json({ error: `Error: ${err.message}` });
  } finally {
    await client.close();
  }
});

app.get('/', (req, res) => {
  // Serve your HTML file
  const filePath = './index.html';
  res.sendFile(filePath, { root: __dirname });
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});
