import React, { useState } from 'react';
import axios from 'axios';
import './PaymentForm.css';

const PaymentForm = () => {
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    
    try {
      const paymentUrl = "https://auth.robokassa.ru/Merchant/Index.aspx?MerchantLogin=pa_website&OutSum=20&InvoiceID=0&Description=%D1%82%D0%B5%D1%81%D1%82%D0%BE%D0%BF%D0%BB%D0%B0%D1%82%D0%B0&SignatureValue=692ffe65be841930a6df18cbf87af69d&IsTest=1";
      window.location.href = paymentUrl;
    } catch (err) {
      setError('Payment initialization failed. Please try again.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <div className="payment-form">
      <h2>Payment Form</h2>
      <form onSubmit={handleSubmit}>
        <div className="form-group">
          <label>Amount:</label>
          <input 
            type="text" 
            value="20.00 ₽" 
            disabled 
          />
        </div>
        <div className="form-group">
          <label>Description:</label>
          <input 
            type="text" 
            value="Test payment" 
            disabled 
          />
        </div>
        {error && <div className="error-message">{error}</div>}
        <button 
          type="submit" 
          disabled={loading}
        >
          {loading ? 'Processing...' : 'Pay Now'}
        </button>
      </form>
    </div>
  );
};

export default PaymentForm;