import { useEffect } from "react";
export default function MyList(){
    useEffect(() => {
        const fetchGames = async () => {
            const response = await fetch("http://localhost:5001/mygamelist?user_id=3316",
                {
                    method:"GET",
                    credentials:"include",
                    headers:{
                        'Authorization':`Bearer ${localStorage.getItem('accessToken')}`
                    }
                }
            )

            const data = await response.json();
            if (data.newAccesToken) {
                localStorage.setItem('accessToken', data.newAccesToken);
            }

            return data.gameList;
        }
        
        const displayGames = async () => {
            const gameList = await fetchGames();
            const ul = document.querySelector("ul");

            gameList.forEach(game => {
                let li = document.createElement('li');
                li.textContent = game;

                ul.appendChild(li); 
            });
        }

        displayGames();
       
        
    },[])

    return (
        <div>
            <p>My Games</p>
            <ul> </ul>
        </div>
    )
}