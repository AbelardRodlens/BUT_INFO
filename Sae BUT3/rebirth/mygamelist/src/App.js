import React, { useEffect } from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Home from './components/Home.js';
import LoginPage from './components/LoginPage.js';
import RegisterPage from './components/RegisterPage.js';
import ChangePasswordPage from './components/ChangePasswordPage.js';
import AboutPage from './components/about.js';
import TermsPage from './components/terms.js';
import PrivacyPage from './components/privacy.js';
import MyList from './components/MyList.js';
import Logout from './components/Logout.js';

 
function App() {
  useEffect(() => {
    // Empêche la fenêtre d'être redimensionnée sous 375px
    const enforceMinWidth = () => {
      if (window.innerWidth < 375) {
        document.body.style.minWidth = '375px';
      } else {
        document.body.style.minWidth = '';
      }
    };

    enforceMinWidth(); // Vérification initiale
    window.addEventListener('resize', enforceMinWidth);

    return () => {
      window.removeEventListener('resize', enforceMinWidth);
    };
  }, []);

  return (
    <Router>
      <div className="App">
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/register" element={<RegisterPage />} />
          <Route path="/change-password" element={<ChangePasswordPage />} />
          <Route path="/about" element={<AboutPage />} />
          <Route path="/terms" element={<TermsPage />} />
          <Route path="/privacy" element={<PrivacyPage />} />
          <Route path="/mygamelist" element={<MyList/>}></Route>
          <Route path="/logout" element={<Logout/>}></Route>
        </Routes>
      </div>
    </Router>
  );
}

export default App;
