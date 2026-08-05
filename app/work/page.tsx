import { ContactBand, PageHero, Shell } from "../components";

const projects = [
  ["Nourish Market", "E-commerce · Web Design", "work-purple", "A vibrant shopping experience for a modern food brand."],
  ["Habit Health", "Product · Responsive Design", "work-orange", "A focused digital platform designed around better daily habits."],
  ["Northstar Living", "Real Estate · Lead Generation", "work-blue", "A calm, conversion-ready property experience for urban buyers."],
  ["Metric Studio", "B2B · WordPress", "work-green", "A confident new digital identity for a fast-moving consultancy."],
];
export default function Work() { return <Shell><main><PageHero eyebrow="SELECTED WORK" title="Built with intention. Designed for momentum." text="A selection of original concept projects showing how we approach different audiences, goals and digital challenges."/><section className="section"><div className="container portfolio-grid">{projects.map(([name, type, color, desc], i)=><article className={`portfolio-card ${color}`} key={name}><div className="portfolio-visual"><span className="project-index">0{i+1}</span><div className="project-screen"><i></i><i></i><i></i><strong>{name}</strong><p>{desc}</p><b>Explore →</b></div></div><small>{type}</small><h2>{name}</h2><p>{desc}</p></article>)}</div></section><ContactBand/></main></Shell>; }
