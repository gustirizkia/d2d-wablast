import TopbarRelawan from "@/Components/TopbarRelawan";
import React, { useEffect } from "react";

export default function LRelawan({ children }) {
    return (
        <div className="bg-gray-600 min-h-screen relative">
            <div className="md:w-1/3 bg-white mx-auto min-h-screen w-full relative">
                <TopbarRelawan />
                <div className="-mt-16">{children}</div>
            </div>
        </div>
    );
}
