/*
 * InfinityLogo — Restwell Retreats
 * Spec: "Smooth, flowing, geometric, rounded, modern. Solid fill, not outlined."
 * Colour: Deep Teal (#1B4D5C) default, or Soft Sand (#F5EDE0) for dark backgrounds.
 * Represents: rest without end, continuity of care, neurodiversity infinity symbol.
 */

interface InfinityLogoProps {
  color?: string;
  size?: number;
}

export default function InfinityLogo({ color = "#1B4D5C", size = 44 }: InfinityLogoProps) {
  const height = size * 0.55;
  return (
    <svg
      width={size}
      height={height}
      viewBox="0 0 80 44"
      fill="none"
      xmlns="http://www.w3.org/2000/svg"
      aria-hidden="true"
      role="img"
    >
      {/* Solid fill infinity — smooth, flowing, geometric, rounded, modern */}
      <path
        d="M40 22
           C40 22 32 6 20 6
           C10.5 6 4 13 4 22
           C4 31 10.5 38 20 38
           C32 38 40 22 40 22
           C40 22 48 6 60 6
           C69.5 6 76 13 76 22
           C76 31 69.5 38 60 38
           C48 38 40 22 40 22Z"
        fill={color}
      />
    </svg>
  );
}
