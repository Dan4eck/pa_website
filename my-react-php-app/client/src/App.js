import React from 'react';
import { BrowserRouter, Routes, Route } from 'react-router-dom';
import PaymentForm from './components/PaymentForm/PaymentForm';
import PaymentSuccess from './components/PaymentSuccess/PaymentSuccess';
import PaymentFail from './components/PaymentFail/PaymentFail';

function App() {
  return (
    <BrowserRouter>
      <div className="App">
        <Routes>
          <Route path="/" element={<PaymentForm />} />
          <Route path="/success" element={<PaymentSuccess />} />
          <Route path="/fail" element={<PaymentFail />} />
        </Routes>
      </div>
    </BrowserRouter>
  );
}

export default App;