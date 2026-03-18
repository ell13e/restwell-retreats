/*
 * Home Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 * Palette: Deep Teal #1B4D5C, Warm Gold #D4A853, Soft Sand #F5EDE0, Sea Glass #A8D5D0
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { IMAGES } from "@/lib/constants";
import { ArrowRight, Home as HomeIcon, Heart, Shield, MapPin } from "lucide-react";

export default function Home() {
  return (
    <Layout>
      {/* Hero Section */}
      <section className="relative min-h-[85vh] flex items-end overflow-hidden">
        <img
          src={IMAGES.heroCoastal}
          alt="A golden-hour view along the Whitstable coastal promenade, with colourful beach huts lining a wide, flat walkway beside the calm sea"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-[#1B4D5C]/80 via-[#1B4D5C]/30 to-transparent" />
        <div className="relative container pb-16 md:pb-24 pt-32">
          <div className="max-w-2xl">
            <p className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              Accessible holidays in Whitstable
            </p>
            <h1 className="text-white text-4xl md:text-5xl lg:text-6xl mb-6 leading-tight">
              Rest easy. A real holiday for both of you.
            </h1>
            <p className="text-[#F5EDE0] text-lg md:text-xl mb-8 leading-relaxed max-w-lg">
              A beautiful, accessible home on the Kent coast — where guests find adventure and carers find a true break.
            </p>
            <div className="flex flex-wrap gap-4">
              <Link
                href="/property"
                className="inline-flex items-center gap-2 bg-[#D4A853] text-[#1B4D5C] font-semibold px-6 py-3 rounded-full hover:bg-[#c49a48] transition-colors duration-300 no-underline text-base"
              >
                See the property <ArrowRight size={18} />
              </Link>
              <Link
                href="/contact"
                className="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white font-medium px-6 py-3 rounded-full border border-white/30 hover:bg-white/25 transition-colors duration-300 no-underline text-base"
              >
                Check availability
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* What is Restwell Retreats? */}
      <section className="py-20 md:py-28">
        <div className="container">
          <div className="max-w-3xl mx-auto text-center">
            <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              What is Restwell Retreats?
            </span>
            <h2 className="text-3xl md:text-4xl mb-8">A holiday, not a care home.</h2>
            <p className="text-lg text-[#3a5a63] leading-relaxed">
              Restwell Retreats is a high-quality, accessible holiday let in Whitstable, Kent. This is not a care home or a clinical facility. It is a proper coastal holiday — with the option of professional, CQC-regulated care support on hand through our partner, Continuity of Care Services. Whether you need a morning check-in or more comprehensive support, it is there if you want it. And if you don't, you simply enjoy the house, the coast, and the freedom.
            </p>
          </div>
        </div>
      </section>

      {/* Who It's For — Dual Audience Cards */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container">
          <div className="text-center mb-12">
            <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              Who it's for
            </span>
            <h2 className="text-3xl md:text-4xl">Two people. One break.</h2>
          </div>
          <div className="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            {/* Guest Card */}
            <div className="bg-[#F5EDE0] rounded-2xl p-8 md:p-10 space-y-4">
              <div className="w-12 h-12 bg-[#A8D5D0]/30 rounded-xl flex items-center justify-center">
                <HomeIcon size={24} className="text-[#1B4D5C]" />
              </div>
              <h3 className="text-xl">For the guest</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                A space designed around you. Wide doorways, level access, and the freedom to explore Whitstable's vibrant coast at your own pace. This is your holiday — not an appointment, not a schedule. Just the sea air, good food, and a comfortable home to come back to.
              </p>
            </div>
            {/* Carer Card */}
            <div className="bg-[#F5EDE0] rounded-2xl p-8 md:p-10 space-y-4">
              <div className="w-12 h-12 bg-[#D4A853]/20 rounded-xl flex items-center justify-center">
                <Heart size={24} className="text-[#D4A853]" />
              </div>
              <h3 className="text-xl">For the carer</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                Peace of mind is the ultimate luxury. With optional professional support available from CCS, you can step back, relax, and enjoy being a partner, a parent, or a friend again — rather than a full-time carer. Rest easy knowing they are safe, happy, and having a proper break too.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Property Snapshot */}
      <section className="py-16 md:py-24">
        <div className="container">
          <div className="grid md:grid-cols-5 gap-8 items-center">
            <div className="md:col-span-3 rounded-2xl overflow-hidden shadow-lg">
              <img
                src={IMAGES.interior}
                alt="A bright, airy living room with wide doorways, natural light, linen sofa, and coastal decor — the interior of the Restwell Retreats holiday home"
                className="w-full h-[350px] md:h-[450px] object-cover"
              />
            </div>
            <div className="md:col-span-2 space-y-6">
              <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em]" style={{ fontFamily: "'Inter', sans-serif" }}>
                Our Whitstable home
              </span>
              <h2 className="text-3xl">101 Russell Drive</h2>
              <p className="text-[#3a5a63] leading-relaxed">
                Our flagship property sits in a quiet residential corner of Whitstable, just a short, flat walk from the famous Tankerton Slopes promenade. It is the perfect base for exploring everything this charming coastal town has to offer — from Harbour Street's independent shops to fresh oysters by the water.
              </p>
              <Link
                href="/property"
                className="inline-flex items-center gap-2 text-[#1B4D5C] font-semibold hover:text-[#D4A853] transition-colors duration-300 no-underline"
              >
                Explore the property <ArrowRight size={18} />
              </Link>
            </div>
          </div>
        </div>
      </section>

      {/* Why Restwell? Mini */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container">
          <div className="text-center mb-12">
            <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              Why Restwell?
            </span>
            <h2 className="text-3xl md:text-4xl">What makes us different</h2>
          </div>
          <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-5xl mx-auto">
            {[
              { icon: <HomeIcon size={22} />, title: "Private & personal", desc: "A real home, not a ward or a hotel room. The whole house is yours." },
              { icon: <Shield size={22} />, title: "Expertly supported", desc: "Optional CQC-regulated care from Continuity of Care Services." },
              { icon: <MapPin size={22} />, title: "Whitstable local", desc: "We know the best accessible spots, the quietest cafes, and the flattest routes." },
              { icon: <Heart size={22} />, title: "Honest & open", desc: "We tell you exactly what to expect — no surprises, no overselling." },
            ].map((item, i) => (
              <div key={i} className="text-center space-y-3 p-6">
                <div className="w-11 h-11 bg-[#A8D5D0]/25 rounded-xl flex items-center justify-center mx-auto text-[#1B4D5C]">
                  {item.icon}
                </div>
                <h3 className="text-lg">{item.title}</h3>
                <p className="text-sm text-[#3a5a63] leading-relaxed">{item.desc}</p>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="relative py-20 md:py-28 overflow-hidden">
        <img
          src={IMAGES.outdoor}
          alt="A person relaxing in a garden chair with a sea view, surrounded by coastal plants and warm afternoon light"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-[#1B4D5C]/75" />
        <div className="relative container text-center">
          <h2 className="text-white text-3xl md:text-4xl mb-4">Ready to plan your break?</h2>
          <p className="text-[#A8D5D0] text-lg mb-8 max-w-lg mx-auto">
            Whether you have dates in mind or just want to ask a question, we are here to help. No pressure, just a conversation.
          </p>
          <div className="flex flex-wrap justify-center gap-4">
            <Link
              href="/property"
              className="inline-flex items-center gap-2 bg-[#D4A853] text-[#1B4D5C] font-semibold px-6 py-3 rounded-full hover:bg-[#c49a48] transition-colors duration-300 no-underline"
            >
              See the property
            </Link>
            <Link
              href="/contact"
              className="inline-flex items-center gap-2 bg-white/15 backdrop-blur-sm text-white font-medium px-6 py-3 rounded-full border border-white/30 hover:bg-white/25 transition-colors duration-300 no-underline"
            >
              Enquire now
            </Link>
          </div>
        </div>
      </section>
    </Layout>
  );
}
