import { useNavigate } from "react-router-dom";

export default function Home() {
    const navigate = useNavigate();

    return (
        <div style={{ padding: 40 }}>
            <h1>ISJS</h1>

            <button onClick={() => navigate("/observer")}>
                Observer
            </button>

            <button onClick={() => navigate("/judge")}>
                Judge
            </button>
        </div>
    );
}