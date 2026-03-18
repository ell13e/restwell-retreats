/*
 * How It Works Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { ArrowRight } from "lucide-react";

export default function HowItWorks() {
  return (
    <Layout>
      {/* Header */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            How it works
          </span>
          <h1 className="text-4xl md:text-5xl mb-6">Simple steps to a real break</h1>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            We believe holidays should be simple. Our model lets you build the break that works for you — combining a beautiful, accessible home with as much or as little support as you need.
          </p>
        </div>
      </section>

      {/* The 2-Step Booking */}
      <section className="py-16 md:py-24">
        <div className="container max-w-4xl">
          <h2 className="text-3xl mb-12 text-center">Two steps. That's it.</h2>
          <div className="grid md:grid-cols-2 gap-8">
            {/* Step 1 */}
            <div className="bg-white rounded-2xl p-8 md:p-10 shadow-sm relative">
              <div className="w-12 h-12 bg-[#1B4D5C] text-white rounded-full flex items-center justify-center text-xl font-bold mb-6" style={{ fontFamily: "'DM Serif Display', serif" }}>
                1
              </div>
              <h3 className="text-xl mb-3">Book your stay</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                Reserve the property at 101 Russell Drive for your chosen dates. It works just like any other holiday let — pick your dates, tell us how many guests, and we will confirm availability.
              </p>
            </div>
            {/* Step 2 */}
            <div className="bg-white rounded-2xl p-8 md:p-10 shadow-sm relative">
              <div className="w-12 h-12 bg-[#D4A853] text-[#1B4D5C] rounded-full flex items-center justify-center text-xl font-bold mb-6" style={{ fontFamily: "'DM Serif Display', serif" }}>
                2
              </div>
              <h3 className="text-xl mb-3">Choose your support</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                Decide if you would like to add care hours. This is entirely optional. You might want a morning check-in, evening support, or something more comprehensive. We will talk it through with you — no pressure, no jargon.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* How Care is Delivered */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            The care side
          </span>
          <h2 className="text-3xl mb-6">Professional support, when you want it</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            All care is delivered by <strong>Continuity of Care Services (CCS)</strong>, an established Kent-based domiciliary care provider. CCS is registered with the Care Quality Commission (CQC), which means the quality and safety of their support is independently regulated.
          </p>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            Care can be flexible. You might want a brief morning call to help with getting up, or evening support to help settle in. Some guests prefer more comprehensive daytime assistance. We will work with you to find what feels right — and it can be adjusted during your stay if your needs change.
          </p>

          <div className="bg-[#F5EDE0] rounded-2xl p-8 mt-8">
            <h3 className="text-xl text-[#1B4D5C] mb-3">Pricing</h3>
            <p className="text-[#8B8B7A] italic">
              PLACEHOLDER – Pricing structure for both accommodation and care hours to be confirmed by client. We will publish clear, transparent pricing here once confirmed.
            </p>
          </div>
        </div>
      </section>

      {/* Bring Your Own Carer */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl">
          <h2 className="text-3xl mb-6">Bring your own carer</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            You are always welcome to bring your own Personal Assistant or carer. The property is designed to accommodate everyone comfortably, and there is no requirement to use CCS support.
          </p>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            That said, even if you bring your own carer, you can still use CCS for "top-up" support — giving your regular carer a few hours off to explore Whitstable on their own. Everyone deserves a break within the break.
          </p>
        </div>
      </section>

      {/* Relationship Between Brands */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Who does what
          </span>
          <h2 className="text-3xl mb-6">Two names, one team</h2>
          <div className="grid md:grid-cols-2 gap-8">
            <div className="bg-[#F5EDE0] rounded-2xl p-8">
              <h3 className="text-xl mb-3">Restwell Retreats</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                The holiday brand. We manage the property, handle your booking, and make sure your stay is comfortable and enjoyable.
              </p>
            </div>
            <div className="bg-[#F5EDE0] rounded-2xl p-8">
              <h3 className="text-xl mb-3">Continuity of Care Services</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                The care provider. CCS delivers all care support — regulated, professional, and flexible. They are the experts in making sure you feel safe and supported.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Reassurance */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl text-center">
          <h2 className="text-3xl mb-6">This is a holiday.</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed max-w-2xl mx-auto mb-8">
            We want to be clear: this is not a care placement, a respite centre, or a clinical environment. It is a holiday home on the Kent coast. You set the pace, you choose the activities, and you decide how much support — if any — you would like. Rest easy.
          </p>
          <Link
            href="/contact"
            className="inline-flex items-center gap-2 bg-[#1B4D5C] text-white font-semibold px-8 py-3 rounded-full hover:bg-[#164350] transition-colors duration-300 no-underline"
          >
            Start planning your break <ArrowRight size={18} />
          </Link>
        </div>
      </section>
    </Layout>
  );
}
