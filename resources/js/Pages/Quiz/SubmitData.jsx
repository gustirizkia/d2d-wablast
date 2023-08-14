import axios from "axios";
import React from "react";
import Swal from "sweetalert2";

export default function SubmitData({ pilihan, soal, foto, target_id }) {
    const handleSubmitData = () => {
        if (!foto) {
            Swal.fire({
                text: "Upload foto bersama responden",
                icon: "info",
            });

            return;
        }

        const formData = new FormData();
        formData.append("image", foto);
        formData.append("pilihan", JSON.stringify(pilihan));
        formData.append("target_id", target_id);

        console.log("pilihan", pilihan);

        axios
            .post("/selesaiQuiz", formData)
            .then((ress) => {
                console.log("ress", ress);
            })
            .catch((err) => {
                console.log("err", err);
            });
    };

    return (
        <div
            onClick={handleSubmitData}
            className="bg-yellow-600 w-full rounded-lg p-3 text-center text-white"
        >
            Submit dan Selesai
        </div>
    );
}
