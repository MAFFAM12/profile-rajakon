import React from 'react'
import { AnimatePresence, motion } from "motion/react";

function CardHoverEffect({ hoveredIndex, index }) {
    return (
        <AnimatePresence>
            {hoveredIndex === index && (
                <motion.span
                    className="absolute inset-0 h-full w-full bg-neutral-200 dark:bg-slate-800/[0.8] block  rounded-3xl"
                    layoutId="hoverBackground"
                    initial={{ opacity: 0 }}
                    animate={{
                        opacity: 1,
                        transition: { duration: 0.15 },
                    }}
                    exit={{
                        opacity: 0,
                        transition: { duration: 0.15, delay: 0.2 },
                    }}
                />
            )}
        </AnimatePresence>
    )
}

export default CardHoverEffect