import React from "react";
import Vector from "../src/vector/Digital Nomad_Flatline.svg";
import { Link } from "@inertiajs/react";

export default function NoQuiz() {
    return (
        <div className="min-h-screen flex flex-col items-center justify-center">
            <img src={Vector} alt="" />
            <div className="text-2xl mt-6 font-semibold text-center">
                Untuk <span className="text-yellow-600">saat ini</span> <br />
                <span className="text-yellow-600">belum ada</span> pertanyaan
            </div>
            <Link
                href="/home"
                className="mt-4 bg-yellow-600 text-white px-5 py-2 rounded-lg"
            >
                Kembali
            </Link>
        </div>
    );
}
