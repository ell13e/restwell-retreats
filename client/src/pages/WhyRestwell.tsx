/*
 * Why Restwell? Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { IMAGES } from "@/lib/constants";
import { ArrowRight } from "lucide-react";

export default function WhyRestwell() {
  return (
    <Layout>
      {/* Header */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Why Restwell?
          </span>
          <h1 className="text-4xl md:text-5xl mb-6">Because a real holiday shouldn't be this hard to find</h1>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            If you or someone you care for has a disability, finding a genuine holiday — one that feels like a holiday, not a medical appointment — can be exhausting. We built Restwell Retreats to change that.
          </p>
        </div>
      </section>

      {/* The Market Gap */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl">
          <h2 className="text-3xl mb-6">What's missing</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            We looked at what was already out there. Most accessible holiday options fall into one of two camps: large-scale group holidays with care teams (great for some, but not private), or standard accessible holiday lets that leave you entirely on your own for care. Very few combine the privacy and comfort of a real home with the option of regulated, professional support.
          </p>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            And for carers? The options are even thinner. Most "respite" services mean the person you care for goes somewhere else. We wanted to create something where both of you can go away together — and both of you can actually rest.
          </p>
        </div>
      </section>

      {/* Core Differentiators */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-4xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            What sets us apart
          </span>
          <h2 className="text-3xl mb-10">Our core differences</h2>
          <div className="space-y-8">
            {[
              {
                title: "Holiday-first, always",
                desc: "We lead with the experience, not the care plan. You are booking a holiday, not a service. The sea air, the independent shops, the oysters — that is what this is about."
              },
              {
                title: "Integrated, regulated care",
                desc: "Unlike most accessible holiday lets, we don't leave you to find your own care. Our partner, Continuity of Care Services, is CQC-regulated and based right here in Kent. Support is professional, flexible, and already arranged."
              },
              {
                title: "A private home, not a centre",
                desc: "You won't share the space with strangers or follow a group schedule. The whole house is yours. You set the pace, you choose the activities, you decide when to do nothing at all."
              },
              {
                title: "Honest accessibility information",
                desc: "We tell you exactly what the property can and can't do. We are upfront about the shingle beach, the narrow pavements in the old town, and anything else that matters. No surprises."
              },
              {
                title: "Flexible support that scales",
                desc: "Need a 30-minute morning check-in? Done. Want more comprehensive daytime support? We can arrange that too. Bringing your own carer but want a few hours of backup? That works as well."
              },
              {
                title: "Local knowledge",
                desc: "We know Whitstable. We know which cafes have step-free access, which routes are flattest, and where to get the best oysters without fighting through crowds. We share all of this with our guests."
              },
            ].map((item, i) => (
              <div key={i} className="flex gap-6 items-start">
                <div className="w-10 h-10 bg-[#A8D5D0]/25 rounded-xl flex items-center justify-center flex-shrink-0 mt-1">
                  <span className="text-[#1B4D5C] font-bold text-sm">{i + 1}</span>
                </div>
                <div>
                  <h3 className="text-xl mb-2">{item.title}</h3>
                  <p className="text-[#3a5a63] leading-relaxed">{item.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>

      {/* CCS Backing */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            The care behind the holiday
          </span>
          <h2 className="text-3xl mb-6">Backed by Continuity of Care Services</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            Continuity of Care Services (CCS) is an established Kent-based domiciliary care provider. They are registered with the Care Quality Commission (CQC), which means their services are independently inspected and regulated.
          </p>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            CCS provides the care support for Restwell Retreats guests. Their team is local, experienced, and understands that this is a holiday — not a clinical setting. They are there to help, not to take over.
          </p>
          <div className="bg-[#F5EDE0] rounded-2xl p-8">
            <h3 className="text-xl text-[#1B4D5C] mb-3">Trust signals</h3>
            <ul className="space-y-2 text-[#3a5a63]">
              <li>CQC Registered Provider: Continuity of Care Services</li>
              <li className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Link to CQC profile or rating to be confirmed by client.</li>
              <li className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Any additional accreditations or memberships to be confirmed by client.</li>
            </ul>
          </div>
        </div>
      </section>

      {/* Who's Behind Restwell */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container">
          <div className="grid md:grid-cols-5 gap-8 items-center max-w-5xl mx-auto">
            <div className="md:col-span-2 rounded-2xl overflow-hidden">
              <img
                src={IMAGES.harbour}
                alt="Whitstable harbour with colourful fishing boats and independent shops along the waterfront"
                className="w-full h-[300px] md:h-[400px] object-cover"
              />
            </div>
            <div className="md:col-span-3 space-y-4">
              <h2 className="text-3xl">Why we built this</h2>
              <p className="text-[#3a5a63] text-lg leading-relaxed">
                Restwell Retreats grew from a simple observation: the people who most need a holiday — disabled people and their carers — often have the hardest time finding one that actually works.
              </p>
              <p className="text-[#3a5a63] text-lg leading-relaxed">
                The team behind CCS has years of experience providing care in people's homes. We saw an opportunity to extend that expertise into something new — a holiday property where the care is already built in, where the accessibility is genuine, and where both the guest and the carer can truly rest easy.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-[#1B4D5C] text-center">
        <div className="container">
          <h2 className="text-white text-3xl mb-4">Convinced? Or still have questions?</h2>
          <p className="text-[#A8D5D0] text-lg mb-8 max-w-md mx-auto">
            Either way, we would love to hear from you. No hard sell — just a conversation.
          </p>
          <Link
            href="/contact"
            className="inline-flex items-center gap-2 bg-[#D4A853] text-[#1B4D5C] font-semibold px-8 py-3 rounded-full hover:bg-[#c49a48] transition-colors duration-300 no-underline"
          >
            Get in touch <ArrowRight size={18} />
          </Link>
        </div>
      </section>
    </Layout>
  );
}
