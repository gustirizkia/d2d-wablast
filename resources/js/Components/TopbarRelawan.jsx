import axios from "axios";
import React, { useEffect, useState } from "react";

export default function TopbarRelawan() {
    const [Data, SetData] = useState(null);
    useEffect(() => {
        axios.get("/getCalon").then((ress) => {
            SetData(ress.data);
        });
    }, []);
    return (
        <>
            <div className="bg-yellow-300 h-16 rounded-b-2xl px-3 flex justify-center flex-col">
                <div className="font-semibold">{Data?.nama}</div>
                <div className="text-sm">
                    Calon Legislatif Dapil {Data?.dapil}
                </div>
            </div>
        </>
    );
}
