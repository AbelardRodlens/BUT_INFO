import React, { useEffect, useState } from 'react';
import './ProfileOverlay.css';
import fetchWrapper from '../fetchWrapper.js';
import { jwtDecode } from "jwt-decode";


const ProfileOverlay = ({ gameList, loadingGames, error, transferDataFunction }) => {
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [memberSince, setMemberSince] = useState('');
  const [bio, setBio] = useState('');
  const [isEditingBio, setIsEditingBio] = useState(false);
  const [avatar, setAvatar] = useState(null);
  const [selectedGames, setSelectedGames] = useState([]);
  const [currentColorIndex, setCurrentColorIndex] = useState(0);

  const colors = [
    "#ff5733",
    "#33ff57",
    "#3357ff",
    "#ff33a8",
    "#a833ff",
    "#33ffe4",
    "#ffe433",
    "#ff8333",
    "#6eff33",
    "#ff3333",
  ];

  const changeColor = () => {
    setCurrentColorIndex((prevIndex) => (prevIndex + 1) % colors.length);
  };

  const handleAvatarChange = (e) => {
    const file = e.target.files[0];
    if (file) {
      setAvatar(URL.createObjectURL(file));
    }
  };

  const handleGameSelection = (e) => {
    const selectedGame = e.target.value;
    if (selectedGames.length < 3 && !selectedGames.includes(selectedGame)) {
      setSelectedGames([...selectedGames, selectedGame]);
    }
  };

  const handleGameRemove = (gameTitle) => {
    setSelectedGames(selectedGames.filter((game) => game !== gameTitle));
  };

  useEffect(() => {

    // Récupère les données user stocké dans le token
    const accessToken = localStorage.getItem('accessToken');
    let userTokenInfos;

    if (accessToken) {
      userTokenInfos = jwtDecode(accessToken);

      // Met à jour ces variables d'états via le token
      setUsername(userTokenInfos.username);
      setEmail(userTokenInfos.email);
      setMemberSince(userTokenInfos.createdAt);
    }


    const fetchUserInfos = async () => {
      try {
      
        const response = await fetchWrapper(`http://localhost:5001/user/account?user_id=${userTokenInfos.user_id || ""}`, "GET", true);

    
        const responseBody = await response.json();

        console.log("Corps de la réponse: ",responseBody);


        setBio(responseBody.data.bio);
        setAvatar(responseBody.data.profile_picture);
        transferDataFunction(responseBody.data.devices.distinctDevices);
      } catch (e) {
        console.error("An Error has occured during the fetching: ", e.message);
      }
    }

    fetchUserInfos();
  }, [])
  const toggleBioEditing = () => {
    setIsEditingBio(!isEditingBio);
  };

  const handleBioChange = (e) => {
    setBio(e.target.value);
  };

  return (
    <div className="overlay-card">
      <div
        className="overlay-editable-header"
        style={{
          backgroundColor: colors[currentColorIndex],
        }}
      ></div>
      <div className="overlay-content">
        <div className="avatar-section">
          <div className="avatar-container">
            <div
              className="avatar"
              style={{
                backgroundImage: `url(${avatar || ""})`,
                backgroundColor: avatar ? "transparent" : "#191c1f",
              }}
            ></div>
            <input
              type="file"
              id="avatar-upload"
              style={{ display: "none" }}
              onChange={handleAvatarChange}
            />
            <label htmlFor="avatar-upload" className="edit-avatar-btn">
              Modifier l'avatar
            </label>
          </div>
        </div>

        

        <div className="account-info">
          <h3 className="account-title_name">{username}</h3>
          <p className="account-details">{email}</p>
          <p className="account-details">Membre depuis: {memberSince}</p>
        </div>
      </div>
      <button onClick={changeColor} className="change-color-btn">
        Changer la couleur
      </button>
    </div>
  );
};

export default ProfileOverlay;
